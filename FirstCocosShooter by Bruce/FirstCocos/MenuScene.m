//
//  MenuScene.m
//  FirstCocos
//
//  Created by Bruce on 5/22/12.
//  Copyright 2012 __MyCompanyName__. All rights reserved.
//

#import "MenuScene.h"
#import "HelloWorldLayer.h"


@implementation MenuScene

-(void)doSomethingTwo:(CCMenuItem *)menuItem
{
    NSLog(@"doSomethingTwo method call");
    [[CCDirector sharedDirector] replaceScene:[HelloWorldLayer scene]];
}
-(void)doSomethingThree:(CCMenuItem *)menuItem
{
    NSLog(@"doSomethingThree method call");
}

-(void)createMenu
{
    // Create some menu items
    CCMenuItemImage * menuItem1 = [CCMenuItemImage itemFromNormalImage:@"myfirstbutton.png"
                                                         selectedImage: @"myfirstbutton_selected.png"
                                                              block:^(id sender) { 
                                                                  [[CCDirector sharedDirector] replaceScene:[HelloWorldLayer scene]];
                                                                   }];
    
    CCMenuItemImage * menuItem2 = [CCMenuItemImage itemFromNormalImage:@"mysecondbutton.png"
                                                         selectedImage: @"mysecondbutton_selected.png"
                                                                target:self
                                                              selector:@selector(doSomethingTwo:)];
    
    
    CCMenuItemImage * menuItem3 = [CCMenuItemImage itemFromNormalImage:@"mythirdbutton.png"
                                                         selectedImage: @"mythirdbutton_selected.png"
                                                                target:self
                                                              selector:@selector(doSomethingThree:)]; 
    
    
    // Create a menu and add your menu items to it
    CCMenu * myMenu = [CCMenu menuWithItems:menuItem1, menuItem2, menuItem3, nil];
    
    // Arrange the menu items vertically
    [myMenu alignItemsVertically];
    
    // add the menu to your scene
    [self addChild:myMenu];
}

-(id)init
{
    if([super init])
    {
        [self createMenu];
    }
    return self;
}
@end
